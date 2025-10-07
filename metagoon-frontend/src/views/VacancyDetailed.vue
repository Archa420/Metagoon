<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "@/services/api";

const route = useRoute();
const router = useRouter();

const vacancy = ref(null);
const user = ref(null);
const comments = ref([]);
const commentText = ref("");

// Fetch vacancy by ID
const fetchVacancy = async () => {
  try {
    const res = await api.get(`/vacancies/${route.params.id}`);
    vacancy.value = res.data;
  } catch (err) {
    console.error("Failed to fetch vacancy:", err);
  }
};

// Fetch authenticated user
const fetchUser = async () => {
  try {
    const res = await api.get("/user");
    user.value = res.data;
  } catch (err) {
    user.value = null;
  }
};

// Delete vacancy
const deleteVacancy = async () => {
  if (!confirm("Do you really want to delete this vacancy?")) return;
  try {
    await api.delete(`/vacancies/${vacancy.value.id}`);
    alert("Vacancy deleted successfully");
    router.push("/vakances"); // redirect after deletion
  } catch (err) {
    console.error("Failed to delete vacancy:", err);
    alert(err.response?.data?.message || "Deletion failed");
  }
};

// Add comment (local only for now)
const addComment = () => {
  if (!commentText.value.trim()) return;
  comments.value.push({
    text: commentText.value,
    user: user.value?.username || "Anonymous",
    created_at: new Date().toLocaleString(),
  });
  commentText.value = "";
};

onMounted(() => {
  fetchVacancy();
  fetchUser();
});
</script>

<template>
  <div v-if="vacancy" class="max-w-3xl mx-auto p-6 space-y-6 bg-white rounded-2xl shadow-lg">
    
    <!-- Vacancy Header -->
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-4xl font-bold text-gray-800">{{ vacancy.title }}</h1>
        <p class="text-gray-500 mt-1">{{ vacancy.company }}</p>
      </div>

      <!-- Delete Button -->
      <button
        v-if="user && vacancy.user_id === user.id"
        @click="deleteVacancy"
        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
      >
        Delete
      </button>
    </div>

    <!-- Company Logo -->
    <div class="flex items-center mt-4">
      <img
        v-if="vacancy.logo_url"
        :src="vacancy.logo_url"
        alt="Company Logo"
        class="w-32 h-32 object-cover rounded-xl border"
      />
    </div>

    <!-- Description & Salary -->
    <p class="mt-4 text-gray-700 leading-relaxed">{{ vacancy.description }}</p>
    <p class="mt-3 font-semibold text-indigo-600 text-lg">Salary: {{ vacancy.salary }}</p>

    <!-- Comments Section -->
    <div class="mt-8">
      <h2 class="text-2xl font-semibold mb-4">Comments</h2>

      <!-- Comment Form -->
      <div class="mb-6">
        <textarea
          v-model="commentText"
          placeholder="Write a comment..."
          class="w-full p-3 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
        <button
          @click="addComment"
          class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
        >
          Post Comment
        </button>
      </div>

      <!-- Comment List -->
      <div class="space-y-4">
        <div
          v-for="(comment, index) in comments"
          :key="index"
          class="p-4 bg-gray-100 rounded-lg"
        >
          <p class="text-gray-800">{{ comment.text }}</p>
          <p class="text-gray-500 text-sm mt-1">
            By {{ comment.user }} • {{ comment.created_at }}
          </p>
        </div>
        <div v-if="comments.length === 0" class="text-gray-400 text-sm">No comments yet.</div>
      </div>
    </div>
  </div>

  <div v-else class="text-center text-gray-500 mt-10">Loading...</div>
</template>

<style scoped>
textarea {
  resize: vertical;
  min-height: 80px;
}
</style>
