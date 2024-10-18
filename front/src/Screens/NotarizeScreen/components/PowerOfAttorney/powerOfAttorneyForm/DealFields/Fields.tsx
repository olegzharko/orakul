import React from 'react';

import General from './components/General';
import Templates from './components/Templates';
import { useFields } from './useFields';

const Fields = () => {
  const meta = useFields();

  return (
    <div className="immovable__fields">
      <Templates initialData={meta.templates} id={meta.id} />
      <General initialData={meta.general} id={meta.id} />
    </div>
  );
};

export default Fields;
