import { Component, OnInit } from '@angular/core';
import { JarwisService } from 'src/app/Services/jarwis.service';
import { TokenService } from 'src/app/Services/token.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  public form = {
    email: null,
    password: null
  }

  public error = null;

  constructor(
    private Jarwis: JarwisService,
    private Token: TokenService
  ) { }

  onSubmit() {
    this.Jarwis.login(this.form).subscribe(
      data => this.handleResponse(data),
      error => this.handleResponse(error)
    );
  }

  handleResponse(data: any) {
    this.Token.handle(data.access_token);
  }

  handleError(error: any) {
    this.error = error.error.error;
  }

  ngOnInit(): void {
  }

}
