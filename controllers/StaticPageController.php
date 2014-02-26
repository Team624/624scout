<?php

class StaticPageController extends Controller {
  
 protected function index() {
  (new IndexView())->render();
 }
 
 protected function schedule() {
  (new ScheduleView())->render();
 }
 
 protected function dataEntry() {
  (new DataEntryView())->render();
 }
 
 protected function setup() {
  (new SetupView())->render();
 }
}