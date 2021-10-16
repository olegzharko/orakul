import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Header from '../../components/Header';
import BankCardsDashboard from '../../components/BankCardsDashboard';

import VisionNavigation from './components/VisionNavigation';
import ClientSide from './components/ClientSide';

import './index.scss';
import ClientSideAndArchiveRoom from './components/ClientSideAndArchiveRoom';
import Archive from './components/Archive';

import Assistants from './components/Assistants';
import routes from '../../routes';

const VisionScreen = () => (
  <>
    <Header />
    <div className="vision container">
      <Switch>
        <Route {...routes.vision.notary}>
          <VisionNavigation />
          <h1>Notary</h1>
        </Route>

        <Route {...routes.vision.assistants}>
          <VisionNavigation />
          <Assistants />
        </Route>

        <Route {...routes.vision.bank}>
          <VisionNavigation />
          <BankCardsDashboard />
        </Route>

        <Route {...routes.vision.archive}>
          <VisionNavigation />
          <Archive />
        </Route>

        <Route {...routes.vision.clientSideRoom}>
          <VisionNavigation />
          <ClientSideAndArchiveRoom />
        </Route>

        <Route {...routes.vision.archiveRoom}>
          <VisionNavigation />
          <ClientSideAndArchiveRoom archive />
        </Route>

        <>
          <VisionNavigation />
          <ClientSide />
        </>
      </Switch>
    </div>
  </>
);

export default VisionScreen;
