export default [
	{
		path: "/",
		name: "home",
		component: () => import("@/views/HomeView.vue"),
		meta: {
			title: "PPDB Kuantan Singing",
			label: "Home",
			requiresAuth: false,
		},
	},
	{
		path: "/statistik",
		name: "statistik",
		component: () => import("@/views/Pages/StatistikPages.vue"),
		meta: {
			title: "PPDB Kuantan Singing",
			label: "Statistik",
			requiresAuth: false,
		},
	},
	{
		path: "/sekolah",
		name: "sekolah",
		component: () => import("@/views/Pages/SekolahPages.vue"),
		meta: {
			title: "PPDB Kuantan Singing",
			label: "Sekolah",
			requiresAuth: false,
		},
	},
	{
		path: "/persyaratan",
		name: "persyaratan",
		component: () => import("@/views/Pages/PersyaratanPages.vue"),
		meta: {
			title: "PPDB Kuantan Singing",
			label: "Persyaratan",
			requiresAuth: false,
		},
	},
	{
		path: "/dashboard",
		name: "ppdbDashboard",
		component: () => import("@/views/Dashboard/DashboardView.vue"),
		meta: {
			title: "PPDB Kuantan Singing",
			label: "Dashboard",
			requiresAuth: true,
		},
	},
	{
		path: "/dashboard/sekolah",
		name: "sekolahDashboard",
		component: () => import("@/views/Admin/DataSekolahView.vue"),
		meta: {
			title: "Data Sekolah Kuantan Singing",
			label: "Sekolah",
			requiresAuth: true,
		},
	},
	{
		path: "/biodata",
		name: "biodata",
		component: () => import("@/views/BiodataView.vue"),
		meta: {
			title: "Biodata",
			label: "Biodata",
			requiresAuth: true,
		},
	},
	{
		path: "/login",
		name: "login",
		component: () => import("@/views/Authentication/SigninView.vue"),
		meta: {
			title: "Login",
			requiresAuth: false,
		},
	},
	{
		path: "/daftar",
		name: "daftar",
		component: () => import("@/views/Authentication/SignupView.vue"),
		meta: {
			title: "Daftar",
			label: "Daftar",
			requiresAuth: false,
		},
	},
	{
		path: "/pendaftaran/",
		name: "pendaftaran",
		component: () => import("@/views/PendaftaranView.vue"),
		meta: {
			title: "Daftar",
			label: "Pendaftaran",
			requiresAuth: true,
		},
	},
	{
		path: "/pendaftaran/verifikasi",
		name: "verifikasi_pendaftaran",
		component: () => import("@/views/VerifikasiView.vue"),
		meta: {
			title: "Verfikasi Pendaftaran",
			label: "Verifikasi Pendaftaran",
			requiresAuth: true,
		},
	},
	{
		path: "/pendaftaran/verifikasi/:id",
		name: "data_verifikasi_pendaftaran",
		component: () => import("@/views/DataPendaftaranView.vue"),
		meta: {
			title: "Verfikasi Pendaftaran",
			label: "Data Verifikasi",
			requiresAuth: true,
		},
	},
	{
		path: "/pendaftaran/:id_registration",
		name: "show_pendaftaran",
		component: () => import("@/views/PendaftaranView.vue"),
		meta: {
			title: "Lihat Pendaftaran",
			label: "Pendaftaran",
			requiresAuth: true,
		},
	},
	{
		path: "/sekolah/daftar",
		name: "daftar_sekolah",
		component: () => import("@/views/Authentication/SchoolSignupView.vue"),
		meta: {
			title: "Daftar",
			label: "Daftar",
			requiresAuth: false,
		},
	},
	{
		path: "/:pathMatch(.*)*",
		name: "NotFound",
		component: () => import("@/views/Errors/Error404View.vue"),
		meta: {
			title: "404 Not Found",
		},
	},
]
