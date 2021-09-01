import React from 'react';

import './index.scss';
import AssistantInfoHeader from './components/AssistantInfoHeader';
import AssistantInfoNavigation from './components/AssistantInfoNavigation';

const AssistantInfo = () => (
  <div className="vision-assistant-info">
    <AssistantInfoHeader />
    <AssistantInfoNavigation />
  </div>
);

export default AssistantInfo;
