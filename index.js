const http = require('http');
const https = require('https');
const Pusher = require('pusher');
const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
 

const app = express();
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }))

// const hostname = 'https://c.patrickattema.nl';

const pusher = new Pusher({
    appId: '507301',
    key: '8dc95d49e9a8f15e0980',
    secret: 'aed12ee8d7ce75bca199',
    cluster: 'eu',
    encrypted: true
});

app.post('/pusher/auth', function (req, res) {
    var socketId = req.body.socket_id;
    var channel = req.body.channel_name;
    var presenceData = {
        user_id: Math.random()
    };
    var auth = pusher.authenticate(socketId, channel, presenceData);
    console.log(auth);
    res.send(auth);
});

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Pusher Server listening on port ${PORT}!`));
