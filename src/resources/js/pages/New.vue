<script setup>
import HeaderBlock from "./components/HeaderBlock.vue";
</script>

<template>
    <div class="container">
        <HeaderBlock/>

        <main class="offset-md-3 col-md-6">
            <form method="post" @submit.prevent="handleCreate">
                <div class="mb-3">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" v-model="form.from_date" class="form-control" id="from_date" required>
                </div>
                <div class="mb-3">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" v-model="form.to_date" class="form-control" id="to_date" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="param_a">Param A</label>
                    <input type="text" v-model="form.param_a" class="form-control" id="param_a" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="param_b">Param B</label>
                    <input type="number" v-model="form.param_b" class="form-control" id="param_b" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </main>
    </div>
</template>

<script>
import {useRouter} from "vue-router";
import axios from "axios";

export default {
    data() {
        return {
            router: useRouter(),
            form: {
                from_date: null,
                to_date: null,
                param_a: null,
                param_b: null,
            }
        }
    },
    methods: {
        async handleCreate() {
            await axios.post('/api/reports', this.form,{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('APP_DEMO_USER_TOKEN')
                }
            })

            await this.router.push('/home')
        },
        handleLogout() {
            localStorage.removeItem('APP_DEMO_USER_TOKEN')
            this.router.push('/')
        }
    }
}
</script>
