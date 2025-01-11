import axiosInstance from '@/api/axiosInstance';
    

export const validAuthor = async (id: number | string) => {
    try {
        const idResponse = await axiosInstance.get(`/api/authors/get/${id}`);
        idResponse.data;
        
        const allResponse = await axiosInstance.get('/api/authors/get/all');
        allResponse.data.map((author: { id: number; }) => {
            if (author.id === id) {
                return author;
            }
        });


    } catch (error) {
        throw Error('Author not found');
    }
};