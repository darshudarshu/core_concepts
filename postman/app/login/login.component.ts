import { Component, OnInit } from "@angular/core";
import { DomSanitizer } from "@angular/platform-browser";
import { MatIconRegistry } from "@angular/material";
import { DataService } from "../service/data.service";
import {
  FormControl,
  FormGroupDirective,
  NgForm,
  Validators
} from "@angular/forms";
@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.css"]
})
export class LoginComponent {
  model: any = {};
  public link : boolean = false ;
//  public iserror=true;
//  public errorMessage="";
//  public errorstack="";  
  constructor(iconRegistry: MatIconRegistry, sanitizer: DomSanitizer,private data: DataService) {
    iconRegistry.addSvgIcon(
      "fb",
      sanitizer.bypassSecurityTrustResourceUrl("assets/img/login/fb.svg")
    );
    iconRegistry.addSvgIcon(
      "google",
      sanitizer.bypassSecurityTrustResourceUrl("assets/img/login/google.svg")
    );
  }
  email = new FormControl("", [Validators.required, Validators.email]);
getErrorMessage() {
   if(this.email.hasError("required"))
   {
     return "must enter a value";
   }else if(this.email.hasError("email"))
   {
       return "Not a valid email";
   }else{
     return "";
   }
}
  pass = new FormControl("", [Validators.required]);
  getPassErrorMessage() {
    if(this.pass.hasError("required"))
   {
     return "must enter a value";
   }else
   {
       return "must enter 6 digit password";
   }
  }
  login() {
   let obs= this.data.UserLoginData(this.model);
   debugger
    obs.subscribe(
      (res:any) =>{
        if(res.message == "200"){
            this.link=true;
         alert("Login Successfull");
       }else if(res.message == "404"){

         alert("User is not Found");
       }
       else if(res.message == "401"){ 
             
         alert("Email is Not Registered");
       } 
       else{
         alert("invalid password");
       }
      //  ,
      //  error => {
      // this.iserror = true;
      // this.errorMessage = error.message;
      //  this.errorstack = error.stack;
      // }
        } );
  }
}
