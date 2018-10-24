import { NgModule } from "@angular/core";
import { Routes, RouterModule } from "@angular/router";
import { ForgotComponent } from "./forgot/forgot.component";
import { LoginComponent } from "./login/login.component";
import { ResetComponent } from "./reset/reset.component";
import { RegisterComponent } from "./register/register.component";
import { AComponent } from "./a/a.component";
import { VerifyComponent } from './verify/verify.component';
import { BComponent } from './b/b.component';
import { FundooNotesComponent } from './fundoo-notes/fundoo-notes.component';
const routes: Routes = [
  {
    path: "",
    redirectTo: 'login',
    pathMatch:"full"
  },
  {
    path: "login",
    component: LoginComponent
  },
  {
    path: "fundoo",
    component: FundooNotesComponent
  },
  {
    path: "b",
    component: BComponent
  },
  {
    path: "register",
    component: RegisterComponent
  },
  {
    path: "forgot",
    component: ForgotComponent
  },
  {
    path: "reset",
    component: ResetComponent
  },
  {
    path: "verify",
    component: VerifyComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
