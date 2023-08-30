const express = require('express');
const http = require('http');
const WebSocket = require('ws');

const app = express();
const server = http.createServer(app);
const wss = new WebSocket.Server({ server });

wss.on('connection', (ws) => {
    console.log('Client connected');

    ws.on('message', (message) => {
        console.log('Message received:', message);

        wss.clients.forEach((client) => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(message);
            }
        });
    });

    ws.on('close', () => {
        console.log('Client disconnected');
    });
});

app.use(express.json());

app.post('/', (req, res) => {
    const data = req.body;
    wss.clients.forEach((client) => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(data));
        }
    });
    console.log('Data received from controller and broadcasted to clients:', data);
    res.sendStatus(200);
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server started on http://localhost:${PORT}`);
});
