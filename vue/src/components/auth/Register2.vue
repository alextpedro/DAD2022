<script setup>
export default {

    data: function () {
        return {
            name: null,
            email: null,
            password: null,
            passwordConfirmation: null,
            type: 'c',
            photo_url: null,
            rules: {
                required: value => !!value || 'Required.',
                counter: value => value == null || value.length <= 20 || 'Max 20 characters',
                email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'Invalid e-mail.'
                },
                password: value => {
                    const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{3,}$/
                    return pattern.test(value) || 'Must contain at least 1 uppercase letter, 1 lowercase letter and 1 number. Min of 3 characters'
                },
                passwordConfirmation: value => value == null || value == this.password || 'Passwords dont match.'
            }
        },
        //hasAlert: null
    },

    methods: {
        register: async function () {
            this.hasAlert = false;

            if (!this.$refs.form.validate()) {
                return;
            }
            const formData = new FormData();

            formData.append('name', this.name);
            formData.append('email', this.email);
            formData.append('password', this.password);
            formData.append('password_confirmation', this.passwordConfirmation);
            formData.append('type', this.type);
            console.log(this.photo_url)

            if (this.photo_url) formData.append('photo_url', this.photo_url);
            const headers = { 'Content-Type': 'multipart/form-data' }

            await axios.post('api/register', formData, headers)
                .then(response => {
                    /*SAVE TOKEN IN SESSION*/
                    const token = response.data.access_token
                    localStorage.setItem('token', token)
                    axios.defaults.headers.common['Authorization'] = token

                    this.$router.push('/login')
                }).catch(error => {
                    this.hasAlert = true
                    console.log(error)
                });
        }
    }
}
</script>

<template>
    <div id="app">
        <v-app id="inspire">
            <v-content>
                <v-container fluid fill-height fill-width>
                    <v-layout align-center justify-center>
                        <v-flex xs12 sm8 md4>
                            <v-card class="elevation-12">
                                <v-toolbar color="primary" dark flat>
                                    <v-toolbar-title>Register</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                        </template>
                                    </v-tooltip>
                                    <v-tooltip right>
                                        <template v-slot:activator="{ on }">
                                        </template>
                                        <span>Codepen</span>
                                    </v-tooltip>
                                </v-toolbar>
                                <v-card-text>
                                    <v-form ref="form">
                                        <v-text-field label="Name" name="name" prepend-icon="person" type="text"
                                            v-model="name" :rules="[rules.required, rules.counter]"></v-text-field>
                                        <v-text-field label="Email" name="email" prepend-icon="person" type="text"
                                            v-model="email"
                                            :rules="[rules.required, rules.counter, rules.email]"></v-text-field>
                                        <v-text-field id="password" label="Password" name="password" prepend-icon="lock"
                                            type="password" v-model="password"
                                            :rules="[rules.required, rules.password]"></v-text-field>
                                        <v-text-field id="passwordConfirmation" label="Password Confirmation"
                                            name="passwordConfirmation" prepend-icon="lock" type="password"
                                            v-model="passwordConfirmation"
                                            :rules="[rules.required, rules.password, rules.passwordConfirmation]"></v-text-field>
                                        <v-file-input v-model="photo_url" placeholder="Pick an avatar"
                                            prepend-icon="camera" label="Avatar"></v-file-input>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="primary" v-on:click.prevent="register()">Register</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
    </div>
</template>

<style>

</style>