import React from 'react';
import { Switch, Route } from 'react-router-dom';

import { AssistantInfoNavigationLinks, VisionNavigationLinks } from '../../enums';

import './index.scss';
import AssistantInfoHeader from './components/AssistantInfoHeader';
import AssistantInfoNavigation from './components/AssistantInfoNavigation';
import AssistantInfoSetPage from './components/AssistantInfoSetPage';
import AssistantInfoOtherActionsPage from './components/AssistantInfoOtherActionsPage';
import AssistantInfoReadingPage from './components/AssistantInfoReadingPage';
import AssistantInfoIssuancePage from './components/AssistantInfoIssuancePage';

const assistantInfoRoutes = {
  set: `${VisionNavigationLinks.assistantInfo}/${AssistantInfoNavigationLinks.set}`,
  otherActions: `${VisionNavigationLinks.assistantInfo}/${AssistantInfoNavigationLinks.otherActions}`,
  reading: `${VisionNavigationLinks.assistantInfo}/${AssistantInfoNavigationLinks.reading}`,
  issuance: `${VisionNavigationLinks.assistantInfo}/${AssistantInfoNavigationLinks.issuance}`
};

const AssistantInfo = () => (
  <div className="vision-assistant-info">
    <AssistantInfoHeader />
    <AssistantInfoNavigation />

    <Switch>
      <Route path={assistantInfoRoutes.set}>
        <AssistantInfoSetPage />
      </Route>

      <Route path={assistantInfoRoutes.reading}>
        <AssistantInfoReadingPage />
      </Route>

      <Route path={assistantInfoRoutes.issuance}>
        <AssistantInfoIssuancePage />
      </Route>

      <Route path={assistantInfoRoutes.otherActions}>
        <AssistantInfoOtherActionsPage />
      </Route>
    </Switch>
  </div>
);

export default AssistantInfo;
