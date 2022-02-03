import { Component, OnInit } from '@angular/core';
import { SnotifyService } from 'ng-snotify';
import { JarwisService } from 'src/app/Services/jarwis.service';

@Component({
  selector: 'app-request-reset',
  templateUrl: './request-reset.component.html',
  styleUrls: ['./request-reset.component.css']
})
export class RequestResetComponent implements OnInit {

  public form = {
    email: null
  }

  public error = null;
  
  constructor(
    private Jarwis: JarwisService,
    private notify: SnotifyService
  ) { }

  ngOnInit(): void {
  }

  onSubmit() {
    this.Jarwis.sendPaswordResetLink(this.form).subscribe(
      data => this.handleResponce(data),
      error => this.handleError(error)
    );
  }

  handleResponce(data: any) {
    console.log(data)
    this.form.email = null
  }

  handleError(error: any) {
    this.error = error.error.error;
  }

}
