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
    export default {
        data () {
            return {
                error: null,
                careProviders: []
            }
        },
        props: ['users'],
        created () {
            let users = JSON.parse(this.users)
            console.log(users)
            
            if (users.count === 0) {
                this.error = 'Je hebt nog geen andere gebruikers.'
            } else {
                this.careProviders = users._embedded.items
            }
        }
    }
</script>
