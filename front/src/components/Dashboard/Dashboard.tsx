import React from 'react';
import { useHistory } from 'react-router-dom';
import './index.scss';
import { v4 as uuidv4 } from 'uuid';
import DashboardSection from './components/DashboardSection';
import DashboardControl from './components/DashbordControl';
import { Section, Props, useDashboard } from './useDashboard';

const Dashboard = (props: Props) => {
  const { selectedType, setSelectedType } = useDashboard(props);
  const history = useHistory();

  const handleClick = async () => {
    try {
      const response = await fetch('api/notarize/add-card', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        }
      });

      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      const json = await response.json();
      const newCardId = json.data.id;

      // Navigate to the new route with the card ID
      history.push(`/power-of-attorney/${newCardId}`);
    } catch (error) {
      console.error('Error creating new card:', error);
      // Handle error appropriately
    }
  };

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
      <button
        className="plus-button"
        type="button"
        onClick={() => handleClick()}
      >
        +
      </button>
    </div>
  );
};

export default Dashboard;
