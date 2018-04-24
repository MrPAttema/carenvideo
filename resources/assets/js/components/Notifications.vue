<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <span>{{this.notificationdata}}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                notificationdata:""
            }
        },
        mounted() {
            console.log('Notifications Mounted.')

            Pusher.logToConsole = true;

            var token = window.axios.defaults.headers.common['X-CSRF-TOKEN'];

            var pusher = new Pusher('8dc95d49e9a8f15e0980', {
                cluster: 'eu',
                encrypted: true,
                authEndpoint: '/pusher/auth',
                auth: {
                    headers: {
                        'X-CSRF-Token': token
                    }
                }
            });

            Echo.join('contactstatus')
            .here('pusher:user.online', (e) => {
                console.log(e)
            });

            // var presenceChannel = pusher.subscribe('presence-contactstatus');
            // presenceChannel.bind('pusher:user.online', function () {
            //     console.log('New subscriber', presenceChannel.members.count)
            // });
            var self = this
            // channel.bind('user.online', function(data) {
            //     console.log(data)
            //     // self.sendIdBack(data.user.id)
            // });           
            // channel.trigger('online', function(data) {
            //     console.log(data)
            //     // self.sendIdBack(data.user.id)
            // });           
        },
        methods: {
            sendIdBack(data) {
                axios.post('/caren/useronline', {
                    data: data
                })
                .then(response => {
                    this.notificationdata = data
                    console.log(response)
                })
            }
        }
    }
</script>
