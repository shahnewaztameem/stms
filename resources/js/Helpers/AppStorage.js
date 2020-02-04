class AppStorage {
    /**Store token in local storage */
    setToken(token){
        localStorage.setItem('token', token);
    }

    /**Store username in local storage */
    setUser(user){
        localStorage.setItem('userName', user);
    }

    /**Store username in local storage */
    setUserType(userType){
        localStorage.setItem('userType', userType);
    }

    /**
     * Call setToken and Username function to store data in
     * local Storage
     */
    storeInLocal(token, user, user_type){
        this.setToken(token);
        this.setUser(user);
        this.setUserType(user_type);
    }

    /**Return token from local Storage */
    getToken(){
        return localStorage.getItem('token');
    }

    /**Return username from local storage */
    getUser(){
        return localStorage.getItem('userName');
    }

    /**Return username from local storage */
    getUserType(){
        return localStorage.getItem('userType');
    }

    /**Remove token and username from local storage */
    ramoveFromLocal(){
        localStorage.removeItem('token');
        localStorage.removeItem('userName');
        localStorage.removeItem('userType');
    }
}

export default AppStorage = new AppStorage();