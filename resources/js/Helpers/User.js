import Token from './Token';
import AppStorage from './AppStorage';
class User {
    /**Axios call to server for login */
    login(data){
       return axios.post('/api/auth/login', data)
              .then(res => {
                  this.processAfterLoggedIn(res.data);
                  return true
                })
              .catch(err => {return err.response.data})
    }
    
    /**
     * Call to store token and username if token is valid
     * @param {response from axios} data 
     */
    processAfterLoggedIn(data){
        const access_token = data.access_token;
        const userName = data.user_name;
        const userType = data.user_type;
        if(Token.isvalid(access_token)){
            AppStorage.storeInLocal(access_token, userName, userType);
        }else{
            console.log('INVALID TOKEN');
        }
    }

    /**
     * Check if there is a token in localstorage
     * @returns Bool
     */
    hasToken(){
        const storedToken = AppStorage.getToken();
        if(storedToken!=null){
            return Token.isvalid(storedToken) ? true : this.logout();
        }
        return false;
    }

    /**Checked if an user is loggedin or not */
    loggedIn(){
        return this.hasToken();
    }

    /**Clear localstorage when logged out*/
    logout(){
        AppStorage.ramoveFromLocal();
        window.location = '/login';
    }

    name(){
        if (this.loggedIn) {
            return AppStorage.getUser();
        }
        return null;
    }

    type(){
        if (this.loggedIn) {
            return AppStorage.getUserType();
        }
        return null;
    }

    id(){
        if (this.loggedIn) {
            const tokenPayload = Token.payload(AppStorage.getToken());
            return tokenPayload.sub;
        }
        return null;
    }
}

export default User = new User();