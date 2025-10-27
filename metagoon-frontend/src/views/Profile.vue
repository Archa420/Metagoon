<script setup>
import { ref, onMounted } from "vue";
import api from "@/services/api";

const user = ref(null);
const isEditing = ref(false);
const form = ref({
  firstname: "",
  lastname: "",
  username: "",
  email: "",
  gender: "",
  birth_date: "",
  role: "",
  company_name: "",
  company_number: "",
  company_address: "",
});
const showDeletePopup = ref(false);
const deletePassword = ref("");

const token = localStorage.getItem("token");

const confirmDelete = async () => {
  if (!deletePassword.value) return alert("Lūdzu ievadiet paroli.");

  try {
    await api.delete("/profile/delete", {
      headers: { Authorization: `Bearer ${token}` },
      data: { password: deletePassword.value },
    });

    alert("Jūsu konts ir dzēsts.");
    localStorage.removeItem("token");
    window.location.href = "/"; // redirect to homepage or login
  } catch (err) {
    console.error(err);
    alert(err.response?.data?.message || "Neizdevās dzēst kontu.");
  }
};
const fetchProfile = async () => {
  try {
    const res = await api.get("/profile", {
      headers: { Authorization: `Bearer ${token}` },
    });
    user.value = res.data;
    form.value = { ...res.data };
  } catch (err) {
    console.error(err);
  }
};

const toggleEdit = () => {
  isEditing.value = !isEditing.value;
  if (isEditing.value && user.value) {
    form.value = { ...user.value };
  }
};

const saveChanges = async () => {
  try {
    const res = await api.put("/profile", form.value, {
      headers: { Authorization: `Bearer ${token}` },
    });
    user.value = res.data;
    isEditing.value = false;
    alert("Profils veiksmīgi atjaunināts!");
  } catch (err) {
    console.error(err);
    alert("Neizdevās atjaunināt profilu.");
  }
};

onMounted(fetchProfile);
</script>

<template>
  <div class="min-h-screen bg-[#0b0c10] text-gray-100 flex justify-center items-start py-16">
    <div class="w-full max-w-3xl rounded-3xl border border-indigo-900/30 bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 p-8 shadow-2xl relative overflow-hidden">
      <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-indigo-800/20 via-fuchsia-800/10 to-transparent pointer-events-none"></div>

      <div class="relative z-10">
        <h2 class="text-4xl font-extrabold mb-8 bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent">
          Mans profils
        </h2>

        <div v-if="user">
          <!-- View Mode -->
          <div v-if="!isEditing" class="space-y-4 text-gray-300">
            <div><strong class="text-gray-400">Vārds:</strong> {{ user.firstname }}</div>
            <div><strong class="text-gray-400">Uzvārds:</strong> {{ user.lastname }}</div>
            <div><strong class="text-gray-400">E-pasts:</strong> {{ user.email }}</div>
            <div><strong class="text-gray-400">Lietotājvārds:</strong> {{ user.username }}</div>
            <div><strong class="text-gray-400">Dzimums:</strong> {{ user.gender }}</div>
            <div><strong class="text-gray-400">Dzimšanas datums:</strong> {{ user.birth_date }}</div>
            <div><strong class="text-gray-400">Statuss:</strong> {{ user.role }}</div>

            <div v-if="user.role === 'uzņēmējs'" class="pt-4 border-t border-gray-800 space-y-2">
              <div><strong class="text-gray-400">Uzņēmuma nosaukums:</strong> {{ user.company_name }}</div>
              <div><strong class="text-gray-400">Uzņēmuma reģ. nr:</strong> {{ user.company_number }}</div>
              <div><strong class="text-gray-400">Juridiskā adrese:</strong> {{ user.company_address }}</div>
            </div>

            <button
              @click="toggleEdit"
              class="mt-6 rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 px-6 py-2 text-sm font-semibold text-white shadow hover:opacity-90 transition"
            >
              Rediģēt profilu
            </button>
          </div>

          <!-- Edit Mode -->
          <div v-else class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm text-gray-400 mb-1">Vārds</label>
                <input v-model="form.firstname" type="text" class="input-style" />
              </div>

              <div>
                <label class="block text-sm text-gray-400 mb-1">Uzvārds</label>
                <input v-model="form.lastname" type="text" class="input-style" />
              </div>
            </div>

            <div>
              <label class="block text-sm text-gray-400 mb-1">E-pasts</label>
              <input v-model="form.email" type="email" class="input-style" />
            </div>

            <div>
              <label class="block text-sm text-gray-400 mb-1">Lietotājvārds</label>
              <input v-model="form.username" type="text" class="input-style" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm text-gray-400 mb-1">Dzimums</label>
                <select v-model="form.gender" class="input-style bg-gray-800/60">
                  <option value="">Izvēlies</option>
                  <option value="vīrietis">Vīrietis</option>
                  <option value="sieviete">Sieviete</option>
                  <option value="cits">Cits</option>
                </select>
              </div>

              <div>
                <label class="block text-sm text-gray-400 mb-1">Dzimšanas datums</label>
                <input v-model="form.birth_date" type="date" class="input-style" />
              </div>
            </div>

            <div>
              <label class="block text-sm text-gray-400 mb-1">Statuss</label>
              <select v-model="form.role" class="input-style bg-gray-800/60">
                <option value="bezdarbnieks">Bezdarbnieks</option>
                <option value="uzņēmējs">Uzņēmējs</option>
              </select>
            </div>

            <div v-if="form.role === 'uzņēmējs'" class="pt-4 border-t border-gray-800 space-y-4">
              <div>
                <label class="block text-sm text-gray-400 mb-1">Uzņēmuma nosaukums</label>
                <input v-model="form.company_name" type="text" class="input-style" />
              </div>

              <div>
                <label class="block text-sm text-gray-400 mb-1">Uzņēmuma reģ. nr</label>
                <input v-model="form.company_number" type="text" class="input-style" />
              </div>

              <div>
                <label class="block text-sm text-gray-400 mb-1">Juridiskā adrese</label>
                <input v-model="form.company_address" type="text" class="input-style" />
              </div>
            </div>

            <div class="flex gap-3 mt-6">
              <button
                @click="saveChanges"
                class="rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 px-6 py-2 text-sm font-semibold text-white shadow hover:opacity-90 transition"
              >
                Saglabāt
              </button>
              <button
                @click="toggleEdit"
                class="rounded-xl border border-gray-700 px-6 py-2 text-sm font-semibold text-gray-300 hover:bg-gray-800 transition"
              >
                Atcelt
              </button>
              <button
                @click="showDeletePopup = true"
                class="rounded-xl border border-red-600 text-red-400 px-6 py-2 text-sm font-semibold hover:bg-red-900/30 transition"
              >
                Dzēst kontu
              </button>

              <!-- Delete confirmation modal -->
              <div
                v-if="showDeletePopup"
                class="fixed inset-0 bg-black/70 backdrop-blur-sm flex justify-center items-center z-50"
              >
                <div class="bg-gray-900 rounded-2xl p-8 w-full max-w-sm border border-gray-700 text-center">
                  <h3 class="text-xl font-semibold text-red-400 mb-4">Apstipriniet konta dzēšanu</h3>
                  <p class="text-gray-400 mb-4 text-sm">
                    Lūdzu ievadiet savu paroli, lai apstiprinātu konta dzēšanu.
                  </p>

                  <input
                    v-model="deletePassword"
                    type="password"
                    placeholder="Parole"
                    class="input-style mb-4"
                  />

                  <div class="flex justify-center gap-4">
                    <button
                      @click="confirmDelete"
                      class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold"
                    >
                      Dzēst
                    </button>
                    <button
                      @click="showDeletePopup = false"
                      class="border border-gray-700 px-4 py-2 rounded-xl text-sm font-semibold text-gray-300 hover:bg-gray-800 transition"
                    >
                      Atcelt
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-else class="text-gray-400 text-center mt-8">Ielādē profilu...</div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.input-style {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border-radius: 0.75rem;
  border: 1px solid rgb(55 65 81);
  background-color: rgba(31, 41, 55, 0.6);
  color: #f3f4f6;
  font-size: 0.875rem;
  outline: none;
}
.input-style:focus {
  border-color: rgb(99 102 241);
  box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.4);
}
</style>
