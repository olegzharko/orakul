import * as React from 'react';

import SectionWithTitle from '../../../../../../../../../../../components/SectionWithTitle';
import TitleInfoDuet from '../../../../../../../../../../../components/TitleInfoDuet';

import { useFields } from './useFields';

const Fields = () => {
  const meta = useFields();

  return (
    <main className="seller">
      <SectionWithTitle title="Продавець">
        <div className="seller__info">
          <div className="seller__info-title" style={{ backgroundColor: meta.developer?.color }}>
            {meta.developer?.title}
          </div>
          <div className="grid">
            {meta.developer?.info.map(({ title, value }) => (
              <TitleInfoDuet title={title} info={value} />
            ))}
          </div>
        </div>
      </SectionWithTitle>

      <SectionWithTitle title="Подружжя">
        <div className="grid">
          {meta.spouse.map(({ title, value }) => (
            <TitleInfoDuet title={title} info={value} />
          ))}
        </div>
      </SectionWithTitle>
    </main>
  );
};

export default Fields;
