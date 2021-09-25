import React from 'react';

import { ClientSideRoomStage } from '../../types';

type ClientSideRoomStagesProps = {
  stage: ClientSideRoomStage;
}

const ClientSideRoomStages = ({ stage }: ClientSideRoomStagesProps) => (
  <div className="stages">
    <div className="title">
      <img src="/images/bar-chart.svg" alt="bar-chart" />
      <span>
        Етапи:
        {' '}
        {stage.title}
      </span>
    </div>
    <div className="stages__list">
      {stage.step.map(({ id, status, time, title }) => (
        <span
          className={`stages__stage ${status ? 'stages__stage-success' : ''}`}
          key={id}
        >
          {title}
          {' - '}
          {time}
        </span>
      ))}
    </div>
  </div>
);

export default ClientSideRoomStages;
