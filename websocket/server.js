const express = require('express');
const http = require('http');
const WebSocket = require('ws');
const { MongoClient, ServerApiVersion } = require('mongodb');

const app = express();
const server = http.createServer(app);
const wss = new WebSocket.Server({ server });

// Conexión a la base de datos de MongoDB Atlas
const uri = "mongodb+srv://narenpertuz:narenpertuz@cluster0.anhgju2.mongodb.net/?retryWrites=true&w=majority";
const dbClient = new MongoClient(uri, {
    serverApi: {
        version: ServerApiVersion.v1,
        strict: true,
        deprecationErrors: true,
    }
});

wss.on('connection', (ws) => {
    console.log('Client connected');

    ws.on('message', async (message) => {
        console.log('Message received:', message);

        // Parsea el mensaje a un objeto JavaScript
        const data = JSON.parse(message);

        // Conexión a la base de datos y guardado del pedido
        try {
            await dbClient.connect();
            const db = dbClient.db("narenpertuz");
            const collection = db.collection("pedidos");
        
            console.log('Inserting data:', data);
        
            // Inserta el pedido en la colección
            const result = await collection.insertOne(data);
            console.log('Pedido guardado en MongoDB:', result.insertedId);
        } catch (error) {
            console.error('Error al guardar el pedido en MongoDB:', error);
        } finally {
            await dbClient.close();
        }
        

        // Envía el mensaje a los clientes conectados
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
