import React from 'react';
import Loader from '../../../../../../components/Loader/Loader';
import { ManagerAppointment } from '../../../../../../types';
import DashboardSection from './components/DashboardSection';
import DashboardControl from './components/DashbordControl';
import './index.scss';
import useDashboard from './useDashboard';

const Dashboard = () => {
  const { selectedType, setSelectedType, appointments, isLoading } = useDashboard();

  if (isLoading) {
    return <Loader />;
  }

  return (
    <div className="dashboard__space">
      <DashboardControl selected={selectedType} onClick={setSelectedType} />
      {appointments && (
        <div className="dashboard__space-main">
          {appointments.map((appointment: ManagerAppointment) => (
            <DashboardSection sectionData={appointment} onCardClick={() => console.log('click')} style={selectedType} />
          ))}
        </div>
      )}
    </div>
  );
};

export default Dashboard;
