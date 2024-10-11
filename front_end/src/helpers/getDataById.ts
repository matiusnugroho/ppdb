interface WithId {
	id: string // Assuming 'id' is of type string, adjust if necessary
}

export function getDataById<T extends WithId>(documents: T[], id: string): T | undefined {
	console.log({ documents, id })
	if (!Array.isArray(documents)) {
		console.error("Expected documents to be an array, but got:", typeof documents)
		return undefined // or throw an error
	}
	return documents.find((doc) => doc.id === id)
}
