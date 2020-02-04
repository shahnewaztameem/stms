class Exception{
    handle(error){
        this.isExpired(error.response.data.error);
    }

    isExpired(err){
        if(err == "Token is expired" || err == "Deleted token passed on request" || err == "Token is invalid" || err == "Access Token not found on request"){
            User.logout();
        }
    }
}

export default Exception = new Exception();