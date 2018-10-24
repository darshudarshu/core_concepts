import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroupDirective, NgForm, Validators} from '@angular/forms';
import {ErrorStateMatcher} from '@angular/material/core';
import { DataService } from "../service/data.service";
import { NgxSpinnerService } from 'ngx-spinner';
@Component({
  selector: 'app-forgot',
  templateUrl: './forgot.component.html',
  styleUrls: ['./forgot.component.css']
})
export class ForgotComponent implements OnInit {
  model : any ={};
  constructor(private data: DataService,private spinner: NgxSpinnerService) { }

  ngOnInit() {
  this.spinner.hide();
  }
  email = new FormControl('', [Validators.required, Validators.email]);

  getErrorMessage() {
    return this.email.hasError('required') ? 'You must enter a value' :
        this.email.hasError('email') ? 'Not a valid email' :
            '';
  }
 forgot() {
   this.spinner.show();
   let obs= this.data.userPasswordRecoveryData(this.model);
    obs.subscribe(
      (res:any) => {
       if(res.message == "200"){
         this.spinner.hide();
         alert("reset link has been sent to your mail");
       }else{
         this.spinner.hide();
         alert("mail not registered");
       }
        } );
  }
 
  
  
}
