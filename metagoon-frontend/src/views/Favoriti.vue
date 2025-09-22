<template>
  <div class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Test Image</h1>

    <div class="flex items-start gap-4 p-6 bg-white rounded-2xl shadow-md">
      <img
        src="http://127.0.0.1:8000/storage/vacancy_logos/jH17Ary2eYqi2s6NMqFwoVZ3F0dnkijxTdULOdcP.png"
        alt="Test Vacancy Logo"
        class="w-32 h-32 rounded-xl object-cover border"
      />
      <div class="flex flex-col">
        <h2 class="text-xl font-semibold text-gray-800">Test Vacancy</h2>
        <p class="text-sm text-gray-500">Test Company</p>
        <p class="mt-2 text-sm text-gray-700">This is a test description.</p>
        <p class="mt-3 font-medium text-indigo-600">Salary: 1000</p>
      </div>
    </div>
  </div>
</template>
