import React from 'react';
import './index.scss';
import DashboardSection from './components/DashboardSection';
import DashboardControl from './components/DashbordControl';
import { Section, Props, useDashboard } from './useDashboard';
import ContentPanel from '../ContentPanel';

const Dashboard = (props: Props) => {
  const { selectedType, setSelectedType } = useDashboard(props);

  return (
    <>
      {props.isChangeTypeButton
        && <DashboardControl selected={selectedType} onClick={setSelectedType} />}
      {props.sections && (
        <div className="dashboard__main">
          {props.sections.map((section: Section) => (
            <DashboardSection
              link={props.link}
              title={section.title}
              style={selectedType}
              cards={section.cards}
            />
          ))}
        </div>
      )}
    </>
  );
};

export default Dashboard;
