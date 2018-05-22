<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="text-align: center;">
                    <div class="panel-heading">Mijn Contacten</div>

                    <div class="error">{{ error }}</div>
                    <div class="panel-body" v-if="!error">
                        <form action="/caren/call/setup" method="GET" v-for="(careProvider, index) in careProviders" :key="index">
                            <button class="btn-primary" style="margin-bottom: 5px;" type="submit">Bel {{ careProvider.care_giver.first_name }} {{ careProvider.care_giver.last_name }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pusher from "pusher-js";

export default {
  data() {
    return {
      error: null,
      careProviders: [],
      pusher: null,
      presenceChannel: null
    };
  },
  props: ["users"],
  created() {

    console.log('state', this.$store.state.test)
    let users = JSON.parse(this.users);

    if (users.count === 0) {
      this.error = "Je hebt nog geen andere gebruikers om mee te bellen.";
    } else {
      this.careProviders = users._embedded.items;
    }

    this.pusher = new Pusher("8dc95d49e9a8f15e0980", {
      cluster: "eu",
      encrypted: true,
      authEndpoint: "/pusher/auth/presence"
    });

    this.presenceChannel = this.pusher.subscribe("presence-connection-channel");

    let self = this

    this.presenceChannel.bind("pusher:subscription_succeeded", function() {
      console.log("New subscriber", self.presenceChannel.members.me);
    });

    this.presenceChannel.bind("pusher:subscription_error", function(err) {
      console.log("SUBSCRIPTION ERROR", err);
    });
  }
};
</script>
