<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Mijn Contacten</div>

                    <div class="panel-body">
                        <form action="/caren/call/setupcall" method="GET">
                            <button class="btn" type="submit">Bel Bram</button>
                        </form>
                        <form action="/caren/call/setupcall" method="GET">
                            <button class="btn" type="submit">Bel Dion</button>
                        </form>
                        <form action="/caren/call/setupcall" method="GET">
                            <button class="btn" type="submit">Bel Kevin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            console.log('Contact List Mounted.')            
        
            Pusher.logToConsole = true;

            var pusher = new Pusher('8dc95d49e9a8f15e0980', {
                cluster: 'eu',
                encrypted: true
            });

            var channel = pusher.subscribe('call.1566404');
            channel.bind('App\\Events\\SendCallRequest', function(data) {
                alert("Je hebt een oproep!");
            });
        }
    }
</script>
