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
  constructor(
    private Jarwis: JarwisService,
    private notify: SnotifyService
  ) { }

  ngOnInit(): void {
  }

  onSubmit() {
    this.Jarwis.sendPaswordResetLink(this.form).subscribe(
      data => this.handleResponce(data),
      error => this.notify.error(error.error.error)
    );
  }

  handleResponce(data: any) {
    console.log(data)
    this.form.email = null
  }

}
