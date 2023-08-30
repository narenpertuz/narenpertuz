const WebSocket = require('ws');

const client = new WebSocket('ws://localhost:3000');

client.on('open', () => {
    console.log('Connected to server');
});

client.on('message', (message) => {
    try {
        const data = JSON.parse(message);
        console.log('Message received:', data);
    } catch (error) {
        console.error('Error parsing message:', error);
    }
});

client.on('close', () => {
    console.log('Connection closed');
});
