<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Video Bellen</div>

                    <div class="panel-body">
                        <span>We bellen.. {{this.body}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body:"Een moment gedult.."
            }
        },
        mounted() {
            console.log('Calling Initialized.')

            Pusher.logToConsole = true;

            var pusher = new Pusher('8dc95d49e9a8f15e0980', {
                cluster: 'eu',
                encrypted: true
            });

            var channel = pusher.subscribe('call.1566404');
            var self = this
            channel.bind('App\\Events\\SendCallRequest', function(data) {
                console.log(data)
                self.sendIdBack(data.user.id)
            });
        },
        methods: {
            sendIdBack(id) {
                axios.post('/caren/call/recieving', {
                    id: id
                })
                .then(id => {
                    this.body = "Gegevens controleren.."
                    console.log(id)
                })
                .catch(e => {
                    console.log(e)
                })
            }
        }
    }
</script>
