import axiosInstance from '@/api/axiosInstance';

export const login = async (username: string, password: string) => {
    try {
        const response = await axiosInstance.post('/login/check', { username: username, password: password });
        return response.data;
    } catch (error) {
        throw new Error('Login failed');
    }
};

 login;
