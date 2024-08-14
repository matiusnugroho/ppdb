<script setup lang="ts">
import { reactive, toRefs, ref } from 'vue'

const formData = ref({
  fullName: 'Devid Jhon',
  phoneNumber: '+990 3343 7865',
  email: 'devidjond45@gmail.com',
  username: 'devidjhon24',
  bio: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque posuere fermentum urna, eu condimentum mauris tempus ut. Donec fermentum blandit aliquet.'
})

import { showToast } from '@/utils/ui/toast'
import { useAuthStore } from '@/stores/auth'
import { usePhotoUpload } from '@/composable/useUpdatePhoto'

const authstore = useAuthStore()
const localState = reactive({
  user: authstore.user ? { ...authstore.user } : null,
  biodata: authstore.biodata ? { ...authstore.biodata } : null
})

const { user, biodata } = toRefs(localState)
const imagePreview = ref<string>('')
const fileFoto = ref<File | null>(null)
const displayPreview = ref<boolean>(false)

const { uploadPhoto, loadingUpdatePhoto, uploadProgress, uploadError } = usePhotoUpload()

const handleSubmit = () => {
  // Handle form submission for personal information
}

const handleCancel = () => {}

const handlePhotoSubmit = async () => {
  const result = await uploadPhoto(fileFoto.value!)
  if (result) {
    showToast({
      message: 'Foto berhasil diperbarui'
    })
    console.log('Photo updated')
  } else {
    showToast({
      message: 'Photo update failed',
      type: 'error'
    })
    console.log('Photo update failed')
  }
  displayPreview.value = false
  fileFoto.value = null
}

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target?.result as string
      biodata.value!.thumbnail_url = e.target?.result as string
    }
    reader.readAsDataURL(file)
    fileFoto.value = file
    displayPreview.value = true
  } else {
    imagePreview.value = 'kosong' // Clear the preview if no file is selected
  }
  target.value = ''
}

const handlePhotoCancel = () => {
  fileFoto.value = null
  displayPreview.value = false
  biodata.value!.thumbnail_url = authstore.biodata!.thumbnail_url
}

const deletePhoto = () => {
  showToast({
    message: 'Photo deleted successfully'
  })
  console.log('Photo deleted')
}

const updatePhoto = () => {}
</script>

<template>
  <div class="grid grid-cols-5 gap-8">
    <!-- Personal Information Section -->
    <div class="col-span-5 xl:col-span-3">
      <div
        class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
      >
        <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
          <h3 class="font-medium text-black dark:text-white">Personal Information</h3>
        </div>
        <div class="p-7">
          <form @submit.prevent="handleSubmit">
            <!-- Full Name Section -->
            <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
              <div class="w-full sm:w-1/2">
                <label
                  class="mb-3 block text-sm font-medium text-black dark:text-white"
                  for="fullName"
                  >Full Name</label
                >
                <div class="relative">
                  <span class="absolute left-4.5 top-4">
                    <font-awesome-icon icon="fa-regular fa-user" />
                  </span>
                  <input
                    v-model="biodata!.nama"
                    class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                    type="text"
                    name="fullName"
                    id="fullName"
                    placeholder="Devid Jhon"
                  />
                  <span
                    class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1"
                  >
                    Invalid username field !
                  </span>
                </div>
              </div>

              <!-- Phone Number Section -->
              <div class="w-full sm:w-1/2">
                <label
                  class="mb-3 block text-sm font-medium text-black dark:text-white"
                  for="phoneNumber"
                  >Phone Number</label
                >
                <input
                  v-model="formData.phoneNumber"
                  class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="text"
                  name="phoneNumber"
                  id="phoneNumber"
                  placeholder="+990 3343 7865"
                />
              </div>
            </div>

            <!-- Email Address Section -->
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="emailAddress"
                >Email Address</label
              >
              <div class="relative">
                <span class="absolute left-4.5 top-4">
                  <font-awesome-icon icon="fa-regular fa-envelope" />
                </span>
                <input
                  v-model="user!.email"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  type="email"
                  name="emailAddress"
                  id="emailAddress"
                  placeholder="devidjond45@gmail.com"
                />
              </div>
            </div>

            <!-- Username Section -->
            <div class="mb-5.5">
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
                for="Username"
                >Username</label
              >
              <input
                v-model="formData.username"
                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                type="text"
                name="Username"
                id="Username"
                placeholder="devidjhon24"
              />
              <span
                class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1"
              >
                Invalid username field !
              </span>
            </div>

            <!-- Bio Section -->
            <div class="mb-5.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="bio"
                >BIO</label
              >
              <div class="relative">
                <span class="absolute left-4.5 top-4">
                  <svg
                    class="fill-current"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g opacity="0.8" clip-path="url(#clip0_88_10224)">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M1.56524 3.23223C2.03408 2.76339 2.66997 2.5 3.33301 2.5H9.16634C9.62658 2.5 9.99967 2.8731 9.99967 3.33333C9.99967 3.79357 9.62658 4.16667 9.16634 4.16667H3.33301C3.11199 4.16667 2.90003 4.25446 2.74375 4.41074C2.58747 4.56702 2.49967 4.77899 2.49967 5V16.6667C2.49967 16.8877 2.58747 17.0996 2.74375 17.2559C2.90003 17.4122 3.11199 17.5 3.33301 17.5H14.9997C15.2207 17.5 15.4326 17.4122 15.5889 17.2559C15.7452 17.0996 15.833 16.8877 15.833 16.6667V10.8333C15.833 10.3731 16.2061 10 16.6663 10C17.1266 10 17.4997 10.3731 17.4997 10.8333V16.6667C17.4997 17.3297 17.2363 17.9656 16.7674 18.4344C16.2986 18.9033 15.6627 19.1667 14.9997 19.1667H3.33301C2.66997 19.1667 2.03408 18.9033 1.56524 18.4344C1.0964 17.9656 0.833008 17.3297 0.833008 16.6667V5C0.833008 4.33696 1.0964 3.70107 1.56524 3.23223Z"
                        fill=""
                      />
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M16.6664 2.39884C16.4185 2.39884 16.1809 2.49729 16.0056 2.67253L8.25216 10.426L7.81167 12.188L9.57365 11.7475L17.3271 3.99402C17.5023 3.81878 17.6008 3.5811 17.6008 3.33328C17.6008 3.08545 17.5023 2.84777 17.3271 2.67253C17.1519 2.49729 16.9142 2.39884 16.6664 2.39884ZM14.8271 1.49402C15.3149 1.00622 15.9765 0.732178 16.6664 0.732178C17.3562 0.732178 18.0178 1.00622 18.5056 1.49402C18.9934 1.98182 19.2675 2.64342 19.2675 3.33328C19.2675 4.02313 18.9934 4.68473 18.5056 5.17253L10.5889 13.0892C10.4821 13.196 10.3483 13.2718 10.2018 13.3084L6.86847 14.1417C6.58449 14.2127 6.28409 14.1295 6.0771 13.9225C5.87012 13.7156 5.78691 13.4151 5.85791 13.1312L6.69124 9.79783C6.72787 9.65131 6.80364 9.51749 6.91044 9.41069L14.8271 1.49402Z"
                        fill=""
                      />
                    </g>
                    <defs>
                      <clipPath id="clip0_88_10224">
                        <rect width="20" height="20" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </span>
                <textarea
                  v-model="formData.bio"
                  class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
                  name="bio"
                  id="bio"
                  rows="6"
                  placeholder="Write your bio here"
                ></textarea>
              </div>
            </div>

            <!-- Save and Cancel Buttons -->
            <div class="flex justify-end gap-4.5">
              <button
                class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white"
                type="button"
                @click="handleCancel"
              >
                Cancel
              </button>
              <button
                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                type="submit"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Your Photo Section -->
    <div class="col-span-5 xl:col-span-2">
      <div
        class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
      >
        <div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
          <h3 class="font-medium text-black dark:text-white">Your Photo</h3>
        </div>
        <div class="p-7">
          <form @submit.prevent="handlePhotoSubmit">
            <!-- User Photo Section -->
            <div class="mb-4 flex items-center gap-3">
              <div class="h-14 w-14 rounded-full">
                <img :src="biodata!.thumbnail_url" alt="User" />
              </div>
              <div>
                <span class="mb-1.5 font-medium text-black dark:text-white">Edit your photo</span>
                <span class="flex gap-2.5">
                  <button class="text-sm font-medium hover:text-primary" @click="deletePhoto">
                    Delete
                  </button>
                  <button class="text-sm font-medium hover:text-primary" @click="updatePhoto">
                    Update
                  </button>
                </span>
              </div>
            </div>

            <!-- File Upload Section -->
            <div
              id="FileUpload"
              class="relative mb-5.5 block w-full cursor-pointer appearance-none rounded border-2 border-dashed border-primary bg-gray py-4 px-4 dark:bg-meta-4 sm:py-7.5"
            >
              <input
                type="file"
                accept="image/*"
                class="absolute inset-0 z-50 m-0 h-full w-full cursor-pointer p-0 opacity-0 outline-none"
                @change="handleFileChange"
              />
              <div class="flex flex-col items-center justify-center space-y-3">
                <span
                  class="text-primary flex h-10 w-10 items-center justify-center rounded-full border border-stroke bg-white dark:border-strokedark dark:bg-boxdark"
                >
                  <font-awesome-icon icon="fa-regular fa-image" />
                </span>
                <p class="text-sm font-medium">
                  <span class="text-primary">Click to upload</span> or drag and drop
                </p>
                <p class="mt-1.5 text-sm font-medium">SVG, PNG, JPG or GIF</p>
              </div>
            </div>
            <div v-if="displayPreview" class="relative mt-4 flex items-center justify-center mb-3">
              <!-- Image Preview -->
              <img :src="imagePreview" alt="Image Preview" class="max-w-full h-auto rounded" />

              <!-- Progress Bar Overlay -->
              <div
                v-if="loadingUpdatePhoto"
                class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded"
              >
                <div class="w-1/2 bg-gray-300 rounded-full h-2.5">
                  <div
                    class="bg-blue-600 h-2.5 rounded-full"
                    :style="{ width: uploadProgress + '%' }"
                  ></div>
                </div>
              </div>
            </div>

            <!-- Save and Cancel Buttons for Photo Section -->
            <div class="flex justify-end gap-4.5">
              <button
                class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white"
                type="button"
                @click="handlePhotoCancel"
              >
                Cancel
              </button>
              <button
                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90"
                @click="handlePhotoSubmit"
                type="button"
                :disabled="loadingUpdatePhoto || !fileFoto"
              >
                Simpan Foto
              </button>
            </div>
            <div class="mt-4">
              <p v-if="uploadError" class="text-red-500 mt-2">{{ uploadError }}</p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
