<script setup>
import HeaderBlock from "./components/HeaderBlock.vue";
</script>

<template>
    <div class="container">
        <HeaderBlock/>

        <main>
            <div class="text-right">
                <a class="btn btn-primary" @click="newReport">New Report</a>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Status</th>
                    <th scope="col">Query</th>
                    <th scope="col">Buttons</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="report in reports">
                    <th scope="row">{{ report.id }}</th>
                    <td>{{ report.status }}</td>
                    <td>{{ report.query }}</td>
                    <td>
                        <a class="btn btn-primary" target="_blank" v-if="report.status === 'ready'" v-bind:href="report.downloadUrl">Download</a>
                    </td>
                </tr>
                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item" :class="{ disabled: !meta.prev_cursor }"><a class="page-link" @click="handlePagination(meta.prev_cursor)">Newer</a></li>
                    <li class="page-item" :class="{ disabled: !meta.next_cursor }"><a class="page-link" @click="handlePagination(meta.next_cursor)">Older</a></li>
                </ul>
            </nav>
        </main>
    </div>
</template>

<script>
import {useRouter} from "vue-router";
import axios from "axios";

let router = useRouter()

export default {
    data() {
        return {
            router: useRouter(),
            reports: [],
            meta: {}
        }
    },
    methods: {
        handlePagination(cursor) {
            if (!cursor) {
                return
            }

            this.loadReports(cursor)
        },
        async loadReports(cursor) {
            if (!cursor) {
                cursor = ''
            }

            const response = await axios.get('/api/reports?cursor=' + cursor, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('APP_DEMO_USER_TOKEN')
                }
            })

            this.reports = response.data.data
            this.meta = response.data.meta
        },
        newReport() {
            this.router.push('/new')
        }
    },
    mounted: function() {
        this.loadReports()
    }
}
</script>
