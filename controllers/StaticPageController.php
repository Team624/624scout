<?php

class StaticPageController extends Controller {
  
 protected function index() {
  (new IndexView())->render();
 }
 
 protected function schedule() {
  (new ScheduleView())->render();
 }
 
 protected function dataEntry() {
  if($_SESSION['entry']==TRUE){
    (new DataEntryView())->render();
  }
 }
 
 protected function setup() {
  if($_SESSION['setup']==TRUE){
  (new SetupView())->render();
  }
 }
 
 protected function rawData() {
  (new RawDataView())->render();
 }
 protected function dataCoverage() {
  (new DataCoverageView())->render();
 }
 protected function teamList() {
  (new TeamListView())->render();
 }
 protected function scoutList() {
  (new ScoutListView())->render();
 }
 protected function testMe() {
  (new TestMeView())->render();
 }
}