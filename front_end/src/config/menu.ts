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
				icon: "document",
				label: "Pendaftaran",
				route: "/pendaftaran",
				role: "all",
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
				route: "/sekolah",
				role: ["sekolah", "verifikator_sekolah"],
			},
			{
				icon: "document",
				label: "Dokumen",
				route: "/dokumen",
				role: "siswa",
			},
		],
	},
]
