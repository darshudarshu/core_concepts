import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from '@angular/router';
@Injectable({
  providedIn: "root"
})
export class DataService {
  private urlRegister = "http://localhost/codeigniter/registration";
  private urlLogin = "http://localhost/codeigniter/login";
  private urlForgot = "http://localhost/codeigniter/forgotPassword";
  private urlReset = "http://localhost/codeigniter/resetPassword";
  private urlGetEmail = "http://localhost/codeigniter/getEmailId";
  private urlVerifyEmail= "http://localhost/codeigniter/veryfyEmailId";

  constructor(private http: HttpClient,private route:ActivatedRoute) {}
  
  UserLoginData(login){
    let userLoginData = new FormData();
    userLoginData.append("email" , login.email )
    userLoginData.append("password" , login.pass )
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlLogin, userLoginData, otheroption)
  }
   UserRegistrationData(register){
    let userRegisterData = new FormData();
    userRegisterData.append("username" , register.name )
    userRegisterData.append("email" , register.email )
    userRegisterData.append("mobilenumber" , register.number )
    userRegisterData.append("password" , register.pass )
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlRegister, userRegisterData, otheroption)
  }
  userPasswordRecoveryData(forgot){
    let userPassRecoveryData = new FormData();
    userPassRecoveryData.append("email" , forgot.email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlForgot, userPassRecoveryData, otheroption)
  }
   UserResetData(reset){
    let userResetData = new FormData();
    userResetData.append("token",this.route.snapshot.queryParamMap.get('token'));
    userResetData.append("pass" , reset.pass)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlReset, userResetData, otheroption)
  }
  getEmail(reset){
    let urlTocken = new FormData();
    urlTocken.append("token",this.route.snapshot.queryParamMap.get('token'));
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlGetEmail, urlTocken, otheroption)
  }
  verifyemail(){
    let verifyEmailId = new FormData();
    verifyEmailId.append("token",this.route.snapshot.queryParamMap.get('token'));
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlVerifyEmail, verifyEmailId, otheroption)
  }
}
