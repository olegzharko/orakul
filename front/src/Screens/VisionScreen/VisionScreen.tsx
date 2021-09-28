import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Header from '../../components/Header';

import { VisionNavigationLinks } from './enums';
import VisionNavigation from './components/VisionNavigation';
import ClientSide from './components/ClientSide';

import './index.scss';
import ClientSideAndArchiveRoom from './components/ClientSideAndArchiveRoom';
import Archive from './components/Archive';
import Bank from './components/Bank';
import Assistants from './components/Assistants';

const VisionScreen = () => (
  <>
    <Header />
    <div className="vision container">
      <Switch>
        <Route path={VisionNavigationLinks.notary} exact>
          <VisionNavigation />
          <h1>Notary</h1>
        </Route>

        <Route path={VisionNavigationLinks.assistants} exact>
          <VisionNavigation />
          <Assistants />
        </Route>

        <Route path={VisionNavigationLinks.bank} exact>
          <VisionNavigation />
          <Bank />
        </Route>

        <Route path={VisionNavigationLinks.archive} exact>
          <VisionNavigation />
          <Archive />
        </Route>

        <Route path={VisionNavigationLinks.clientSideRoom} exact>
          <VisionNavigation />
          <ClientSideAndArchiveRoom />
        </Route>

        <Route path={VisionNavigationLinks.archiveRoom} exact>
          <VisionNavigation />
          <ClientSideAndArchiveRoom archive />
        </Route>

        {/* <Route path={VisionNavigationLinks.otherNotaryActions} exact>
          <VisionNavigation />
          <h1>Other Notary Actions</h1>
        </Route> */}

        <>
          <VisionNavigation />
          <ClientSide />
        </>
      </Switch>
    </div>
  </>
);

export default VisionScreen;
