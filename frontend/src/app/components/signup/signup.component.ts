import { Component, OnInit } from '@angular/core';
import { JarwisService } from 'src/app/Services/jarwis.service';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {

  public form = {
    name: null,
    email: null,
    password: null,
    password_confirmation: null
  };

  public error = [];

  constructor(private JarWis: JarwisService) { }

  onSubmit() {
    this.JarWis.signup(this.form).subscribe(
      data => console.log(data),
      error => this.handleError(error)
    );
  }

  handleError(error: any) {
    this.error = error.error.errors;
  }

  ngOnInit(): void {
  }

}
