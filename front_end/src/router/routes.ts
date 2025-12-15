export default [
	{
		path: "/",
		name: "root",
		component: () => import("@/layouts/HomeLayout.vue"),
		meta: {
			title: "PPDB Kuantan Singingi",
			label: "Home",
			requiresAuth: false,
		},
		children: [
			{
				path: "",
				name: "home",
				component: () => import("@/views/HomeView.vue"),
				meta: {
					title: "PPDB Kuantan Singingi",
					label: "Home",
					requiresAuth: false,
				},
			},
			{
				path: "statistik",
				name: "statistik",
				component: () => import("@/views/Pages/StatistikPages.vue"),
				meta: {
					title: "PPDB Kuantan Singingi",
					label: "Statistik",
					requiresAuth: false,
				},
			},
			{
				path: "sekolah",
				name: "sekolah",
				component: () => import("@/views/Pages/SekolahPages.vue"),
				meta: {
					title: "PPDB Kuantan Singingi",
					label: "Sekolah",
					requiresAuth: false,
				},
			},
			{
				path: "persyaratan",
				name: "persyaratan",
				component: () => import("@/views/Pages/PersyaratanPages.vue"),
				meta: {
					title: "PPDB Kuantan Singingi",
					label: "Persyaratan",
					requiresAuth: false,
				},
			},
		],
	},

	{
		path: "/dashboard",
		name: "ppdbDashboard",
		component: () => import("@/views/Dashboard/DashboardView.vue"),
		meta: {
			title: "PPDB Kuantan Singingi",
			label: "Dashboard",
			requiresAuth: true,
		},
	},
	{
		path: "/dashboard/akun",
		name: "akunDashboard",
		component: () => import("@/views/Admin/AkunView.vue"),
		meta: {
			title: "PPDB Kuantan Singingi",
			label: "Akun",
			requiresAuth: true,
		},
	},
	{
		path: "/dashboard/sekolah",
		name: "sekolahDashboard",
		component: () => import("@/views/Admin/DataSekolahView.vue"),
		meta: {
			title: "Data Pendaftaran",
			label: "Data Pendaftaran",
			requiresAuth: true,
		},
	},
	{
		path: "/dashboard/persyaratan",
		name: "persyaratanDashboard",
		component: () => import("@/views/Admin/PersyaratanView.vue"),
		meta: {
			title: "Data Persyaratan Sekolah Kuantan Singingi",
			label: "Persyaratan",
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
		path: "/sekolah/me",
		name: "profil_sekolah",
		component: () => import("@/views/Sekolah/ProfileSekolahView.vue"),
		meta: {
			title: "Data Sekolah",
			label: "Data Sekolah",
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
	{
		path: "/dashboard/master-sekolah",
		name: "masterSekolah",
		component: () => import("@/views/Admin/MasterSekolahView.vue"),
		meta: {
			title: "Master Data Sekolah",
			label: "Data Sekolah",
			requiresAuth: true,
		},
	},
	{
		path: "/dashboard/sekolah/:id",
		name: "sekolahDetail",
		component: () => import("@/views/Admin/SekolahDetailView.vue"),
		meta: {
			title: "Detail Sekolah",
			label: "Detail Sekolah",
			requiresAuth: true,
		},
	},
]
