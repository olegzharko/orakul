import React from 'react';
import './index.scss';
import { v4 as uuidv4 } from 'uuid';
import DashboardSection from './components/DashboardSection';
import DashboardControl from './components/DashbordControl';
import { Section, Props, useDashboard } from './useDashboard';

const Dashboard = (props: Props) => {
  const { selectedType, setSelectedType } = useDashboard(props);

  if (!props.sections?.length) return null;

  return (
    <div className="dashboard">
      {props.isChangeTypeButton
        && <DashboardControl selected={selectedType} onClick={setSelectedType} />}
      {props.sections && (
        <div className="dashboard__main">
          {props.sections.map((section: Section) => (
            <DashboardSection
              key={uuidv4()}
              title={section.title}
              style={selectedType}
              cards={section.cards}
              haveStatus={props.haveStatus}
            />
          ))}
        </div>
      )}
    </div>
  );
};

export default Dashboard;
