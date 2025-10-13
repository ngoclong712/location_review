<template>
<div>
    <Header></Header>
    <main class="min-h-screen">
        <RouterView></RouterView>
    </main>
    <Footer></Footer>
</div>
</template>

<script setup lang="ts">
import {RouterView} from "vue-router";
import Header from "../components/common/Header.vue";
import Footer from "../components/common/Footer.vue";
</script>
