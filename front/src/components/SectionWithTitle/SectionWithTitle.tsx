import React from 'react';
import './index.scss';

type Props = {
  title: string;
  children: React.ReactNode;
  onClear?: () => void;
}

const SectionWithTitle = ({ title, children, onClear }: Props) => (
  <div className="section-with-title">
    <div className="section-with-title__header">
      <h2 className="section-title">{title}</h2>
      {onClear && (
        <button type="button" className="clear-button">
          <img
            src="/icons/clear-form.svg"
            alt="close"
            className="clear-icon"
            onClick={onClear}
          />
        </button>
      )}
    </div>
    <div className="section-with-title__body">
      {children}
    </div>
  </div>
);

export default SectionWithTitle;
