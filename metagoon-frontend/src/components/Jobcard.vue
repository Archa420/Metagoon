<script setup>
defineProps({
  logo: String,
  title: String,
  company: String,
  salary: String,
  description: String,
})
</script>

<template>
  <div class="card">
    <img :src="logo" alt="company logo" class="logo" />
    <div class="content">
      <h2>{{ title }}</h2>
      <p class="salary">Likme: {{ salary }}</p>
      <p class="desc">{{ description }}</p>
      <p class="company">{{ company }}</p>
    </div>
  </div>
</template>

<style src="../styles/jobcard.css"></style>
