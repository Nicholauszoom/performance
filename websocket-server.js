const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8080 });

console.log('WebSocket server listening on port 8080');
wss.on('connection', (ws) => {
    console.log('Client connected');
  
    ws.on('message', (message) => {
      console.log(`Received message: ${message}`);
  
      // Handle the WebSocket message here
    });
  
    ws.on('close', () => {
      console.log('Client disconnected');
    });
  });
  