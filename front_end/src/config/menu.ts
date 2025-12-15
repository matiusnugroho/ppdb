export const menuGroups = [
	{
		name: "Data Diri",
		menuItems: [
			{
				icon: "home",
				label: "Dashboard",
				route: "/dashboard",
				role: "all",
			},
			{
				icon: "toga",
				label: "Data Pendaftaran",
				route: "/dashboard/sekolah",
				role: "super_admin",
			},
			{
				icon: "home",
				label: "Data Sekolah",
				route: "/dashboard/master-sekolah",
				role: "super_admin",
			},
			{
				icon: "toga",
				label: "Akun",
				route: "/dashboard/akun",
				role: "super_admin",
			},
			{
				icon: "document",
				label: "Persyaratan",
				route: "/dashboard/persyaratan",
				role: "super_admin",
			},
			{
				icon: "document",
				label: "Pendaftaran",
				route: "/pendaftaran",
				role: ["siswa", "sekolah", "verifikator_sekolah"],
			},
			{
				icon: "user-circle",
				label: "Biodata",
				route: "/biodata",
				role: ["siswa"],
			},
			{
				icon: "user-circle",
				label: "Data Sekolah",
				route: "/sekolah/me",
				role: ["sekolah", "verifikator_sekolah"],
			},
			{
				icon: "user-circle",
				label: "Data Verifikasi",
				route: "/pendaftaran/verifikasi",
				role: ["sekolah", "verifikator_sekolah"],
			},
		],
	},
]
