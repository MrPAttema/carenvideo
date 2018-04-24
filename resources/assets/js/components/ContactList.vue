<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Mijn Contacten</div>

                    <div class="panel-body">
                        <form action="/caren/call/setup" method="GET">
                            <button class="btn" type="submit">Bel Bram</button>
                        </form>
                        <form action="/caren/call/recieving" method="GET">
                            <button class="btn" type="submit">Bel Dion</button>
                        </form>
                        <form action="/caren/call/setup" method="GET">
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
        mounted() {
            console.log('Contact List Mounted.')        
        }
    }
</script>
