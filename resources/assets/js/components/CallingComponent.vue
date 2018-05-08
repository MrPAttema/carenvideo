<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Video Bellen</div>

                    <div class="panel-body">
                        <span>We bellen.. {{this.body}}</span>
                    </div>

                    <div class="room">
                        <div class="video-container">
                            <video class="streamVideo" ref="streamVideo" autoplay></video>
                            <video class="ownVideo" ref="ownVideo" autoplay></video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pusher from "pusher-js";
import SimplePeer from "simple-peer";

export default {
  props: ["data"],
  data() {
    return {
      body: "Een moment geduld..",
      isInitiator: false,
      hasAnswer: false,
      pusher: null,
      p: null,
      presenceChannel: null
    };
  },
  mounted() {
    console.log("Calling Initialized.");

    // var pusher = new Pusher("8dc95d49e9a8f15e0980", {
    //   cluster: "eu",
    //   encrypted: true
    // });

    // var channel = pusher.subscribe("presence-contactstatus");
    // var self = this;
    // channel.bind("call.request", function(data) {
    //   self.sendIdBack(data);
    // });

    // get video/voice stream
    navigator.getUserMedia(
      { video: true, audio: true },
      this.gotMedia,
      function(err) {
        console.log("MEDIA ERROR", err);
      }
    );
  },
  methods: {
    sendIdBack(data) {
      axios
        .post("/caren/call/recieving", {
          data: data
        })
        .then(response => {
          this.body = "Gegevens controleren..";
          console.log(response);
        });
    },

    gotMedia(stream) {
      // var isInitiator = false;
      // var hasAnswer = false;
      console.log("pusher before", this.pusher);

      this.pusher = new Pusher("8dc95d49e9a8f15e0980", {
        cluster: "eu",
        encrypted: true,
        // authEndpoint: 'http://carenvideo.patrickattema.nl/pusher/auth'
        // authEndpoint: "http://localhost:5000/pusher/auth"
        authEndpoint: "/pusher/auth/presence"
      });

      console.log("pusher after", this.pusher);

      this.presenceChannel = this.pusher.subscribe(
        "presence-connection-channel"
      );

      let self = this;

      this.presenceChannel.bind("pusher:subscription_succeeded", function() {
        console.log("New subscriber", self.presenceChannel.members.count);
        self.startPeer(self.presenceChannel.members.count, stream);
      });

      this.presenceChannel.bind("pusher:subscription_error", function(err) {
        console.log('SUBSCRIPTION ERROR', err)
      });
    },

    startPeer(count, stream) {
      let ownVideo = this.$refs.ownVideo;
      ownVideo.srcObject = stream;
      ownVideo.play();

      if (count === 2) {
        this.isInitiator = true;
      }

      let self = this;

      this.presenceChannel.bind("client-send-signal-event", function(data) {
        console.log("Clien Send Signal Event with data: ", data);
        self.p.signal(data.msg);
      });

      this.p = new SimplePeer({
        initiator: this.isInitiator,
        trickle: true,
        stream: stream
      });

      this.p.on("signal", function(data) {
        console.log("On signal listener with data: ", data);
        var triggered = self.presenceChannel.trigger(
          "client-send-signal-event",
          {
            msg: JSON.stringify(data)
          }
        );
      });

      this.p.on("error", function(err) {
        console.log("error", err);
      });

      this.p.on("connect", function() {
        console.log("CONNECT");
      });

      this.p.on("data", function(data) {
        console.log("data: " + data);
      });

      this.p.on("stream", function(stream) {
        console.log("GOT STREAM");
        let video = self.$refs.streamVideo;
        // var video = document.createElement("video");
        // document.body.appendChild(video);

        video.srcObject = stream;
        video.play();
      });
    }
  }
};
</script>
