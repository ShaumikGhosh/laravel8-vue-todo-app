<template>
<div>
    <Header/>
    <Table/>
</div>
</template>

<script>
import Header from '../components/Header'
import Table from '../components/Table';

export default {
    name: 'Profile',
    components: {
        Table,
        Header
    },
}
</script>