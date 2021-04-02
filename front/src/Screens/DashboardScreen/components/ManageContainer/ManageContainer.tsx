import * as React from 'react';
import Navigation from './components/Navigation';
import { useManageContainer } from './useManageContainer';

const ManageContainer = () => {
  const meta = useManageContainer();

  return (
    <main className="manage">
      <Navigation selected={meta.selectedNav} />
    </main>
  );
};

export default ManageContainer;
