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
        props: ['data'],
        data() {
            return {
                body:"Een moment geduld.."
            }
        },
        mounted() {
            console.log('Calling Initialized.')

            var pusher = new Pusher('8dc95d49e9a8f15e0980', {
                cluster: 'eu',
                encrypted: true
            });

            var channel = pusher.subscribe('presence-contactstatus');
            var self = this
            channel.bind('call.request', function(data) {
                self.sendIdBack(data)
            });
        },
        methods: {
            sendIdBack(data) {
                axios.post('/caren/call/recieving', {
                    data: data
                })
                .then(response => {
                    this.body = "Gegevens controleren.."
                    console.log(response)
                })
            }
        }
    }
</script>
