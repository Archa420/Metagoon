<script setup>
import JobCard from '@/components/JobCard.vue'

// Example jobs (later you can fetch from API)
const jobs = [
  {
    logo: 'https://placehold.co/80x80',
    title: 'Frontend Developer',
    company: 'Metagoon',
    salary: '€2500 / month',
    description: 'Work with Vue 3, Tailwind, and Vite to build modern UIs.',
  },
  {
    logo: 'https://placehold.co/80x80',
    title: 'Backend Developer',
    company: 'Tech Corp',
    salary: '€3000 / month',
    description: 'Develop APIs with Node.js and maintain cloud infrastructure.',
  },
]
</script>

<template>
  <div class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Vakances</h1>
    
    <div class="space-y-4">
      <JobCard
        v-for="(job, index) in jobs"
        :key="index"
        v-bind="job"
      />
    </div>
  </div>
</template>
