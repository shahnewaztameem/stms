class Token{

    /**
     * Check if the payload is valid or not 
     * based on iss
     * @returns Bool
     * @param {Decoded payload} token 
     */
    isvalid(token){
        const payload = this.payload(token);
        if(payload){
            return payload.iss == "http://stms.test/api/auth/login" ? true : false;
        }
        return false;
    }

    /**
     * The JWT token has 3part. "Header, Payload, Signature"
     * Split the token for decoding payload part.
     */
    payload(token){
        if (token != null) {
            const payload = token.split('.')[1];
            return this.decode(payload);
        }
        return false;
    }

    /**Decode the payload for ISS=>"Issued Srever" */
    decode(payload){
        if (this.isBase64(payload)) {
            return JSON.parse(atob(payload));
        } else {
            return false;
        }
    }

    /**Security check if someone change the token or given by own */
    isBase64(str){
        try {
            return btoa(atob(str)).replace(/=/g, "") == str;
        } catch (error) {
            return false;
        }
    }
}

export default Token = new Token();