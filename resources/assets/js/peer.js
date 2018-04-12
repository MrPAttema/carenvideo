// get video/voice stream
navigator.getUserMedia({ video: true, audio: true }, gotMedia, function (err) {
    console.log("MEDIA ERROR", err);
})

function gotMedia(stream) {

    var isInitiator = false;
    var hasAnswer = false;

    var pusher = new Pusher('8dc95d49e9a8f15e0980', {
        cluster: 'eu',
        encrypted: true,
        authEndpoint: 'https://c.patrickattema.nl/pusher/auth'
    });

    var presenceChannel = pusher.subscribe('presence-connection-channel');

    presenceChannel.bind('pusher:subscription_succeeded', function () {
        console.log('New subscriber', presenceChannel.members.count)
        startPeer(presenceChannel.members.count);
    });

    function startPeer(count) {
        if (count === 2) {
            isInitiator = true;
        }

        presenceChannel.bind('client-send-offer-event', function (data) {
            console.log('Send offer back to other peer', data);
            p.signal(data.msg);
        })

        var p = new SimplePeer({
            initiator: isInitiator,
            trickle: true,
            stream: stream
        });

        p.on('signal', function (data) {
            if (isInitiator) {
                console.log('Is initiator ', data)
                var triggered = presenceChannel.trigger('client-send-offer-event', {
                    msg: JSON.stringify(data)
                })
            } else if (!isInitiator) {
                console.log('Is not initiator ', data)
                var triggered = presenceChannel.trigger('client-send-offer-event', {
                    msg: JSON.stringify(data)
                })
            }
        });

        p.on('error', function (err) {
            console.log('error', err)
        })

        p.on('connect', function () {
            console.log('CONNECT')
        })

        p.on('data', function (data) {
            console.log('data: ' + data)
        })

        p.on('stream', function (stream) {
            console.log('GOT STREAM');
            var video = document.createElement('video')
            document.body.appendChild(video)

            video.srcObject = stream
            video.play()
        })
    }
}