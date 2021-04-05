import * as React from 'react';
import './index.scss';
import Address from './components/Address';
import Citizenship from './components/Citizenship';
import Contacts from './components/Contacts';
import Fio from './components/Fio';
import Passport from './components/Passport';
import Statement from './components/Statement';
import PowerOfAttorney from './components/PowerOfAttorney';

const ClientsFields = () => (
  <main className="clients">
    <Fio />
    <Contacts />
    <Citizenship />
    <Passport />
    <Address />
    <Statement />
    <PowerOfAttorney />
  </main>
);

export default ClientsFields;
