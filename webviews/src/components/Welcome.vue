<template>
<div>
    <Header/>
    <h1 style="text-align:center;margin-top:200px">Welcome to (Laravel + Vue.js) SPA.</h1>
</div>
</template>

<script>
import Header from '../components/Header'
export default {
    name: 'Welcome',
    components : {
        Header
    },
}
</script>