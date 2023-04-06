<template>
    <main class="form-signin w-100 m-auto">
        <form method="post" @submit.prevent="handleLogin">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <ul class="text-danger" v-for="(value, index) in errors" :key="index" v-if="typeof errors === 'object'">
                <li>{{ value[0] }}</li>
            </ul>
            <p class="text-danger" v-if="errors">{{ errors }}</p>

            <div class="form-floating">
                <input
                    type="email"
                    class="form-control"
                    id="floatingInput"
                    placeholder="name@example.com"
                    v-model="form.email"
                    required
                >
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input
                    type="password"
                    class="form-control"
                    id="floatingPassword"
                    placeholder="Password"
                    v-model="form.password"
                >
                <label for="floatingPassword">Password</label>
            </div>
            <br>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
    </main>
</template>

<script>
import axios from 'axios';
import {useRouter} from "vue-router";

export default {
    data() {
        return {
            router: useRouter(),
            form: {
                email: '',
                password: '',
            },
            errors: '',
        }
    },
    methods: {
        async handleLogin() {
            this.errors = ''

            try {
                const result = await axios.post('/api/auth/login', this.form)
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token)
                    await this.router.push('home')
                }
            } catch (e) {
                if(e && e.response.data && e.response.data.errors) {
                    this.errors = Object.values(e.response.data.errors)
                } else {
                    this.errors = e.response.data.message || ""
                }
            }
        }
    }
}
</script>

<style>
.form-signin {
    max-width: 330px;
    padding: 15px;
}

.form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
</style>
