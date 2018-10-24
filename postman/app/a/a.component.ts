import { Component, OnInit } from "@angular/core";
import { DomSanitizer } from "@angular/platform-browser";
import { MatIconRegistry } from "@angular/material";
import { NgModule } from "@angular/core";
import { Router } from "@angular/router";

import {
  FormControl,
  FormGroupDirective,
  NgForm,
  Validators
} from "@angular/forms";
@Component({
  selector: "app-a",
  templateUrl: "./a.component.html",
  styleUrls: ["./a.component.css"]
})
export class AComponent implements OnInit {
  constructor() {}
public name="darshu";

 ngOnInit(){}

}
